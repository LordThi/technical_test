// src/services/apiUser.js
import axios from 'axios';


const API_URL = '/api/login';

const submitLogin = async (credentials) => {
    try {
        const response = await axios.post(API_URL, credentials);
        return response;
    } catch (error) {
        throw new Error(error.response?.data?.message || 'Login failed');
    }
};

export default {
    submitLogin,
};
