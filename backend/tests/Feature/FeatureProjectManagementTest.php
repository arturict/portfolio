<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;

class FeatureProjectManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user; // Keep this for convenience if you still want a default user for many tests

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Create a default user instance
        // Sanctum::actingAs($this->user); // Remove from setUp
    }

    /**
     * Test authenticated user can create a project.
     */
    public function test_authenticated_user_can_create_project()
    {
        Sanctum::actingAs($this->user); // Authenticate the user for this test

        $projectData = [
            'name' => $this->faker->company, // Changed from title to name
            'description' => $this->faker->paragraph,
            'demo_link' => $this->faker->optional()->url,
            'github_link' => $this->faker->optional()->url,
            'image' => $this->faker->optional()->imageUrl(),
            'status' => 'planned', // status is required
        ];

        $response = $this->postJson('/api/projects', $projectData);

        $response->assertStatus(201)
            ->assertJsonStructure([ // ProjectResource needs to align with 'name'
                'data' => ['id', 'name', 'description', 'demo_link', 'github_link', 'image', 'status', 'user_id']
            ])
            ->assertJsonFragment(['name' => $projectData['name'], 'user_id' => $this->user->id]);

        $this->assertDatabaseHas('projects', [
            'name' => $projectData['name'], // Check for name
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Test unauthenticated user cannot create a project.
     */
    public function test_unauthenticated_user_cannot_create_project()
    {
        // No Sanctum::actingAs() call, so the request is unauthenticated
        $projectData = ['title' => 'Test Project', 'description' => 'A test description.'];
        $response = $this->postJson('/api/projects', $projectData);
        $response->assertStatus(401);
    }


    /**
     * Test project creation fails with validation errors.
     */
    public function test_project_creation_fails_with_validation_errors()
    {
        Sanctum::actingAs($this->user); // Authenticate the user for this test
        
        // Missing name
        $response = $this->postJson('/api/projects', [
            'description' => 'Test Description', 
            'status' => 'planned'
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['name']);

        // Missing status
        $response = $this->postJson('/api/projects', [
            'name' => 'Test Project Name', 
            'description' => 'Test Description'
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['status']);

        // Invalid status
        $response = $this->postJson('/api/projects', [
            'name' => 'Test Project Name', 
            'status' => 'invalid_status'
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['status']);
    }

    /**
     * Test user can update their own project.
     * Note: UpdateProjectRequest allows partial updates and uses 'name' if 'title' was a mistake.
     * For consistency, I'll assume Project model and resource use 'name'.
     */
    public function test_user_can_update_their_own_project()
    {
        Sanctum::actingAs($this->user); // Authenticate the user for this test
        // Ensure the factory creates a project with 'name' if that's the DB column
        $project = Project::factory()->create(['user_id' => $this->user->id, 'name' => 'Original Project Name']); 
        $updateData = ['name' => 'Updated Project Name']; // Update 'name'

        $response = $this->putJson("/api/projects/{$project->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $updateData['name']]); // Check for 'name'
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => $updateData['name']]);
    }

    /**
     * Test user cannot update another user's project.
     */
    public function test_user_cannot_update_others_project()
    {
        Sanctum::actingAs($this->user); // Authenticate the user for this test
        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id, 'name' => 'Others Project']);
        $updateData = ['name' => 'Attempted Update'];

        $response = $this->putJson("/api/projects/{$project->id}", $updateData);
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test unauthenticated user cannot update project.
     */
    public function test_unauthenticated_user_cannot_update_project()
    {
        $projectToUpdate = Project::factory()->create(['user_id' => $this->user->id, 'name' => 'Project Name Before Update']);
        // No Sanctum::actingAs() call

        $updateData = ['name' => 'Attempted Update Unauth'];
        $response = $this->putJson("/api/projects/{$projectToUpdate->id}", $updateData);
        $response->assertStatus(401);
    }

    /**
     * Test user can delete their own project.
     */
    public function test_user_can_delete_their_own_project()
    {
        Sanctum::actingAs($this->user); // Authenticate the user for this test
        $project = Project::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/projects/{$project->id}");
        $response->assertStatus(200) // Assuming a 200 OK with a message
                 ->assertJson(['message' => 'Project deleted successfully']);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /**
     * Test user cannot delete another user's project.
     */
    public function test_user_cannot_delete_others_project()
    {
        Sanctum::actingAs($this->user); // Authenticate the user for this test
        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->deleteJson("/api/projects/{$project->id}");
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test unauthenticated user cannot delete project.
     */
    public function test_unauthenticated_user_cannot_delete_project()
    {
        // $this->user is created in setUp, but not authenticated for this test
        $project = Project::factory()->create(['user_id' => $this->user->id]); // Project exists
        // No Sanctum::actingAs() call

        $response = $this->deleteJson("/api/projects/{$project->id}");
        $response->assertStatus(401);
    }

    /**
     * Test anyone can view projects index.
     */
    public function test_anyone_can_view_projects_index()
    {
        // No Sanctum::actingAs() call
        Project::factory()->count(3)->create(['name' => 'Test Project Name']); // Ensure 'name' is set if that's what resource expects

        $response = $this->getJson('/api/projects');
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'name']]]) // Expect 'name'
            ->assertJsonCount(3, 'data');
    }

    /**
     * Test anyone can view a single project.
     */
    public function test_anyone_can_view_a_single_project()
    {
        // No Sanctum::actingAs() call
        $project = Project::factory()->create(['name' => 'Specific Project Name']); // Ensure 'name'

        $response = $this->getJson("/api/projects/{$project->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $project->name]); // Expect 'name'
    }
}
