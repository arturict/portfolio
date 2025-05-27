import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api from '../services/api';

const ProjectForm = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const isEditMode = !!id;
  
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    demo_link: '',
    github_link: '',
    image: '',
    status: 'in_progress', // Default status
  });
  
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(isEditMode);

  useEffect(() => {
    if (isEditMode) {
      const fetchProject = async () => {
        try {
          const response = await api.getProject(id);
          const projectData = response.data.data || response.data;
          setFormData({
            title: projectData.title || '',
            description: projectData.description || '',
            demo_link: projectData.demo_link || '',
            github_link: projectData.github_link || '',
            image: projectData.image || '',
            status: projectData.status || 'in_progress',
          });
          setLoading(false);
        } catch (err) {
          setError('Failed to load project data. Please try again later.');
          setLoading(false);
          console.error('Error fetching project for edit:', err);
        }
      };

      fetchProject();
    }
  }, [id, isEditMode]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      if (isEditMode) {
        await api.updateProject(id, formData);
      } else {
        await api.createProject(formData);
      }
      navigate('/');
    } catch (err) {
      setError(
        err.response?.data?.message ||
          `Failed to ${isEditMode ? 'update' : 'create'} project. Please try again.`
      );
      console.error(`Error ${isEditMode ? 'updating' : 'creating'} project:`, err);
    } finally {
      setLoading(false);
    }
  };

  if (loading && isEditMode) return <div className="loading">Loading project data...</div>;

  return (
    <div className="project-form">
      <h2>{isEditMode ? 'Edit Project' : 'Create New Project'}</h2>
      
      {error && <div className="alert alert-danger">{error}</div>}
      
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="title">Title</label>
          <input
            type="text"
            id="title"
            name="title"
            value={formData.title}
            onChange={handleChange}
            required
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="description">Description</label>
          <textarea
            id="description"
            name="description"
            value={formData.description}
            onChange={handleChange}
            rows="5"
            required
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="demo_link">Demo Link</label>
          <input
            type="url"
            id="demo_link"
            name="demo_link"
            value={formData.demo_link}
            onChange={handleChange}
            placeholder="https://example.com"
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="github_link">GitHub Link</label>
          <input
            type="url"
            id="github_link"
            name="github_link"
            value={formData.github_link}
            onChange={handleChange}
            placeholder="https://github.com/username/repo"
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="image">Image URL</label>
          <input
            type="url"
            id="image"
            name="image"
            value={formData.image}
            onChange={handleChange}
            placeholder="https://example.com/image.jpg"
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="status">Status</label>
          <select
            id="status"
            name="status"
            value={formData.status}
            onChange={handleChange}
          >
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="on_hold">On Hold</option>
          </select>
        </div>
        
        <div className="form-actions">
          <button 
            type="submit" 
            className="btn btn-primary" 
            disabled={loading}
          >
            {loading ? 'Saving...' : isEditMode ? 'Update Project' : 'Create Project'}
          </button>
          
          <button 
            type="button" 
            className="btn btn-secondary" 
            onClick={() => navigate('/')}
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  );
};

export default ProjectForm;