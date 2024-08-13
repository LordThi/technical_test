// src/components/PrivateRoute.jsx
import React from 'react';
import { Navigate, useLocation } from 'react-router-dom';

const PrivateRoute = ({ element, ...rest }) => {
    const location = useLocation();
    const token = localStorage.getItem('adminToken');

    return token ? (
        element
    ) : (
        <Navigate to="/admin/login" state={{ from: location }} />
    );
};

export default PrivateRoute;
