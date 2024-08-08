// src/services/apiCandidat.js
import axios from 'axios';

const fetchCandidats = async () => {
    return axios.get('/api/candidats');
};

const fetchTypesPoste = async () => {
    return axios.get('/api/types_poste');
};

const fetchNiveaux = async () => {
    return axios.get('/api/niveaux');
};

const fetchQuizzes = async () => {
    return axios.get('/api/quizzes');
};

const submitCandidat = async (data) => {
    return axios.post('/api/candidats', data);
};

const updateCandidat = async (id, data) => {
    return axios.put(`/api/candidats/${id}`, data);
};

const deleteCandidat = async (id) => {
    return axios.delete(`/api/candidats/${id}`);
};

export default {
    fetchCandidats,
    fetchTypesPoste,
    fetchNiveaux,
    fetchQuizzes,
    submitCandidat,
    updateCandidat,
    deleteCandidat
};
