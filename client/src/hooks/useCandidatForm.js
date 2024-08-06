import {useState} from 'react';

const useForm = () => {
    const [formData, setFormData] = useState({
        firstname: '',
        lastname: '',
        mail: ''
    });

    const handleChange = (event) => {
        const {id, value} = event.target;
        setFormData({
            ...formData,
            [id]: value
        });
    };

    const isFormComplete = () => {
        return formData.firstname !== '' && formData.lastname !== '' && formData.mail !== '';
    };

    return {
        formData,
        handleChange,
        isFormComplete,
        handleSubmit: (event) => handleSubmit(event, formData)
    };
};

const handleSubmit = async (event, formData) => {
    event.preventDefault();
    try {
        await apiService.submitCandidat(formData);
        console.log('Success!');
    } catch (error) {
        console.error('Error:', error);
    }
};

export default useForm;
