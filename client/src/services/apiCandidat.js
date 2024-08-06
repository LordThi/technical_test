import axios from 'axios';

const submitCandidat = async (data) => {
    return axios.post('/api/candidat', data);
};

export default {
    submitCandidat
};
