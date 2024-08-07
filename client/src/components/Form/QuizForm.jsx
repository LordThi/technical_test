import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Button, Form, Table, Modal, Alert } from 'react-bootstrap';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faPenToSquare, faPlus, faTrashCan} from "@fortawesome/free-solid-svg-icons";

const Quiz = () => {
    const [quizzes, setQuizzes] = useState([]);
    const [selectedQuiz, setSelectedQuiz] = useState(null);
    const [showModal, setShowModal] = useState(false);
    const [modalMode, setModalMode] = useState('create'); // 'create' or 'edit'
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(null);
    const [quizForm, setQuizForm] = useState({
        titre: '',
        tempsMax: 0,
        nombreQuestions: 0
    });

    useEffect(() => {
        fetchQuizzes();
    }, []);

    const fetchQuizzes = async () => {
        try {
            const response = await axios.get('/api/quizzes');
            setQuizzes(response.data);
        } catch (error) {
            console.error('Error fetching quizzes:', error);
        }
    };

    const handleShowModal = (mode, quiz = null) => {
        setModalMode(mode);
        if (mode === 'edit' && quiz) {
            setSelectedQuiz(quiz);
            setQuizForm({
                titre: quiz.titre,
                tempsMax: quiz.tempsMax,
                nombreQuestions: quiz.nombreQuestions
            });
        } else {
            setSelectedQuiz(null);
            setQuizForm({
                titre: '',
                tempsMax: 0,
                nombreQuestions: 0
            });
        }
        setShowModal(true);
    };

    const handleCloseModal = () => setShowModal(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setQuizForm(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            // Convertir les valeurs en entiers
            const dataToSend = {
                ...quizForm,
                tempsMax: parseInt(quizForm.tempsMax, 10),
                nombreQuestions: parseInt(quizForm.nombreQuestions, 10)
            };

            if (modalMode === 'create') {
                await axios.post('/api/quizzes', dataToSend);
                setSuccess('Quiz created successfully');
            } else if (modalMode === 'edit' && selectedQuiz) {
                await axios.put(`/api/quizzes/${selectedQuiz.id}`, dataToSend);
                setSuccess('Quiz updated successfully');
            }
            fetchQuizzes();
            handleCloseModal();
        } catch (error) {
            setError('Error saving quiz');
            console.error('Error saving quiz:', error);
        }
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete(`/api/quizzes/${id}`);
            setSuccess('Quiz deleted successfully');
            fetchQuizzes();
        } catch (error) {
            setError('Error deleting quiz');
            console.error('Error deleting quiz:', error);
        }
    };

    return (
        <div>

            {error && <Alert variant="danger">{error}</Alert>}
            {success && <Alert variant="success">{success}</Alert>}

            <Table striped bordered hover>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Temps Max</th>
                    <th>Nombre de Questions</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                {console.log(quizzes)}
                {quizzes.map(quiz => (
                    <tr key={quiz.id}>
                        <td>{quiz.id}</td>
                        <td>{quiz.titre}</td>
                        <td>{quiz.tempsMax}</td>
                        <td>{quiz.nombreQuestions}</td>
                        <td className="d-flex justify-content-around">
                            <Button
                                variant="warning"
                                onClick={() => handleShowModal('edit', quiz)}
                            >
                                <FontAwesomeIcon icon={faPenToSquare} />
                            </Button>
                            <Button
                                variant="danger"
                                onClick={() => handleDelete(quiz.id)}
                            >
                                <FontAwesomeIcon icon={faTrashCan} />
                            </Button>
                        </td>
                    </tr>
                ))}
                </tbody>
            </Table>
            <Button variant="primary" onClick={() => handleShowModal('create')}>
                <FontAwesomeIcon icon={faPlus} />
            </Button>

            <Modal show={showModal} onHide={handleCloseModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{modalMode === 'create' ? 'Create Quiz' : 'Edit Quiz'}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form onSubmit={handleSubmit}>
                        <Form.Group controlId="formTitre">
                            <Form.Label>Titre</Form.Label>
                            <Form.Control
                                type="text"
                                name="titre"
                                value={quizForm.titre}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group controlId="formTempsMax">
                            <Form.Label>Temps Max (en minutes)</Form.Label>
                            <Form.Control
                                type="number"
                                name="tempsMax"
                                value={quizForm.tempsMax}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group controlId="formNombreQuestions">
                            <Form.Label>Nombre de Questions</Form.Label>
                            <Form.Control
                                type="number"
                                name="nombreQuestions"
                                value={quizForm.nombreQuestions}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Button variant="primary" type="submit">
                            {modalMode === 'create' ? 'Create' : 'Update'}
                        </Button>
                    </Form>
                </Modal.Body>
            </Modal>
        </div>
    );
};

export default Quiz;
