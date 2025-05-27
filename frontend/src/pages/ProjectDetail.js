import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';
import api from '../services/api';

const ProjectDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [project, setProject] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const isAuthenticated = localStorage.getItem('token');

  useEffect(() => {
    const fetchProject = async () => {
      try {
        const response = await api.getProject(id);
        setProject(response.data.data || response.data);
        setLoading(false);
      } catch (err) {
        setError('Failed to load project details. Please try again later.');
        setLoading(false);
        console.error('Error fetching project:', err);
      }
    };

    fetchProject();
  }, [id]);

  const handleDelete = async () => {
    if (!window.confirm('Are you sure you want to delete this project? This action cannot be undone.')) {
      return;
    }

    try {
      await api.deleteProject(id);
      navigate('/');
    } catch (err) {
      setError('Failed to delete project. Please try again.');
      console.error('Error deleting project:', err);
    }
  };

  if (loading) return <div className="loading">Loading project details...</div>;
  if (error) return <div className="error">{error}</div>;
  if (!project) return <div className="not-found">Project not found.</div>;

  return (
    <div className="project-detail">
      <h1>{project.title}</h1>
      
      {project.image && (
        <div className="project-image">
          <img src={project.image} alt={project.title} />
        </div>
      )}
      
      <div className="project-info">
        <h2>Description</h2>
        <p>{project.description}</p>
        
        <div className="project-links">
          {project.demo_link && (
            <a
              href={project.demo_link}
              target="_blank"
              rel="noopener noreferrer"
              className="btn btn-primary"
            >
              View Live Demo
            </a>
          )}
          
          {project.github_link && (
            <a
              href={project.github_link}
              target="_blank"
              rel="noopener noreferrer"
              className="btn btn-secondary"
            >
              View Source Code
            </a>
          )}
        </div>
        
        {project.status && (
          <div className="project-status">
            <strong>Status:</strong> {project.status}
          </div>
        )}
      </div>
      
      {isAuthenticated && (
        <div className="project-actions">
          <Link to={`/projects/edit/${id}`} className="btn btn-edit">
            Edit Project
          </Link>
          <button onClick={handleDelete} className="btn btn-delete">
            Delete Project
          </button>
        </div>
      )}
      
      <Link to="/" className="btn btn-back">
        Back to All Projects
      </Link>
    </div>
  );
};

export default ProjectDetail;