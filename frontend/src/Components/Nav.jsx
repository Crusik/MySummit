import React, { useState } from 'react';
import { Button } from 'react-bootstrap';
import './Nav.css';

function Nav() {
  const [activeItem, setActiveItem] = useState('Patients');
  const [isOpen, setIsOpen] = useState(false);

  // Get user from localStorage
  const user = JSON.parse(localStorage.getItem('user') || '{}');

  const handleLogout = () => {
    localStorage.removeItem('authToken');
    localStorage.removeItem('user');
    window.location.reload();
  };

  const getUserInitials = () => {
    if (!user?.name) return 'U';
    return user.name
      .split(' ')
      .map((n) => n[0])
      .join('')
      .toUpperCase()
      .slice(0, 2);
  };

  return (
    <>
      <div className='nav-header'>
        <div className='nav-header-content'>
          <h1 className='nav-title'>MySummit Patient Portal</h1>
          <div className='nav-user-section'>
            <div className='user-profile-container'>
              <div className='user-avatar'>{getUserInitials()}</div>
              <div>
                <p className='user-name'>{user?.name}</p>
              </div>
            </div>
            <Button
              variant='light'
              size='lg'
              onClick={handleLogout}
              className='logout-btn'
            >
              Logout
            </Button>
          </div>
        </div>
      </div>
    </>
  );
}

export default Nav;
