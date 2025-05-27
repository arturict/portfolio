import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Navbar = () => {
  const navigate = useNavigate();
  const isAuthenticated = localStorage.getItem('token');
  
  const handleLogout = () => {
    localStorage.removeItem('token');
    navigate('/login');
  };
  
  return (
    <nav className="navbar">
      <div className="navbar-logo">
        <Link to="/">Portfolio</Link>
      </div>
      <div className="navbar-links">
        <Link to="/">Projects</Link>
        {isAuthenticated ? (
          <>
            <Link to="/projects/new">Add Project</Link>
            <button onClick={handleLogout}>Logout</button>
          </>
        ) : (
          <>
            <Link to="/login">Login</Link>
            <Link to="/register">Register</Link>
          </>
        )}
      </div>
    </nav>
  );
};

export default Navbar;