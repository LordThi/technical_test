// src/components/AdminCandidats.jsx
import React, { useState, useEffect } from 'react';
import { Table, Button, Modal, Form, Alert } from 'react-bootstrap';
import { faPenToSquare, faTrashCan, faUserPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import apiCandidat from '../../services/apiCandidat';

const AdminCandidats = () => {
    const [candidats, setCandidats] = useState([]);
    const [typesPoste, setTypesPoste] = useState([]);
    const [niveaux, setNiveaux] = useState([]);
    const [quizzes, setQuizzes] = useState([]);
    const [showModal, setShowModal] = useState(false);
    const [editingCandidat, setEditingCandidat] = useState(null);
    const [newCandidat, setNewCandidat] = useState({
        prenom: '',
        nom: '',
        email: '',
        typePosteId: 0,
        typePoste: '',
        niveauId: 0,
        niveau:'',
        quizId: 0,
        datePassage: '',
        tempsTotal: 0,
    });
    const [error, setError] = useState(null);

    useEffect(() => {
        loadData();
    }, []);

    const loadData = async () => {
        try {
            const [candidatsResponse, typesPosteResponse, niveauxResponse, quizzesResponse] = await Promise.all([
                apiCandidat.fetchCandidats(),
                apiCandidat.fetchTypesPoste(),
                apiCandidat.fetchNiveaux(),
                apiCandidat.fetchQuizzes()
            ]);
            setCandidats(candidatsResponse.data);
            setTypesPoste(typesPosteResponse.data);
            setNiveaux(niveauxResponse.data);
            setQuizzes(quizzesResponse.data);
        } catch (error) {
            console.error('Error loading data:', error);
        }
    };

    const handleShowModal = (candidat = null) => {
        setEditingCandidat(candidat);
        setNewCandidat(candidat || {
            prenom: '',
            nom: '',
            email: '',
            typePosteId: 0,
            niveauId: 0,
            quizId: 0,
            datePassage: '',
            tempsTotal: 0,
        });
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
        setEditingCandidat(null);
        setError(null);
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setNewCandidat(prev => ({ ...prev, [name]: value }));
    };

    const handleSave = async () => {
        try {
            const dataToSend = {
                ...newCandidat,
                tempsTotal: parseInt(newCandidat.tempsTotal, 10),
                adminDashboard: true,
            }
            if (editingCandidat) {
                await apiCandidat.updateCandidat(editingCandidat.id, dataToSend);
            } else {
                await apiCandidat.submitCandidat(dataToSend);
            }
            await loadData();
            handleCloseModal();
        } catch (error) {
            setError('Error saving candidat');
            console.error('Error:', error);
        }
    };

    const handleDelete = async (id) => {
        try {
            await apiCandidat.deleteCandidat(id);
            await loadData();
        } catch (error) {
            setError('Error deleting candidat');
            console.error('Error:', error);
        }
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const formattedDate = date.toLocaleDateString('fr-FR');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${formattedDate} ${hours}:${minutes}`;
    };

    return (
        <div>
            <h2>Candidats</h2>
            {error && <Alert variant="danger">{error}</Alert>}
            <Button variant="primary" onClick={() => handleShowModal()}>
                <FontAwesomeIcon icon={faUserPlus} />
            </Button>
            <Table striped bordered hover className="mt-3">
                <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Type Poste</th>
                    <th>Niveau</th>
                    <th>Quiz</th>
                    <th>Date Passage</th>
                    <th>Temps Total (min)</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                {candidats.map(candidat => (
                    <tr key={candidat.id}>
                        <td>{candidat.prenom}</td>
                        <td>{candidat.nom}</td>
                        <td>{candidat.email}</td>
                        <td>{candidat.typePoste || 'N/A'}</td>
                        <td>{candidat.niveau || 'N/A'}</td>
                        <td>{candidat.quiz || 'N/A'}</td>
                        <td>{candidat.datePassage ? formatDate(candidat.datePassage.date): '--'}</td>
                        <td>{candidat.tempsTotal}</td>
                        <td>
                            <Button variant="warning" onClick={() => handleShowModal(candidat)}>
                                <FontAwesomeIcon icon={faPenToSquare} />
                            </Button>
                            <Button variant="danger" className="ml-2" onClick={() => handleDelete(candidat.id)}>
                                <FontAwesomeIcon icon={faTrashCan} />
                            </Button>
                        </td>
                    </tr>
                ))}
                </tbody>
            </Table>

            <Modal show={showModal} onHide={handleCloseModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{editingCandidat ? 'Modifier le Candidat' : 'Ajouter un Candidat'}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form>
                        <Form.Group controlId="formFirstname">
                            <Form.Label>Prénom</Form.Label>
                            <Form.Control
                                type="text"
                                name="prenom"
                                value={newCandidat.prenom}
                                onChange={handleChange}
                                placeholder="Jean-Claude"
                            />
                        </Form.Group>
                        <Form.Group controlId="formLastname">
                            <Form.Label>Nom</Form.Label>
                            <Form.Control
                                type="text"
                                name="nom"
                                value={newCandidat.nom}
                                onChange={handleChange}
                                placeholder="Duss"
                            />
                        </Form.Group>
                        <Form.Group controlId="formEmail">
                            <Form.Label>Email</Form.Label>
                            <Form.Control
                                type="email"
                                name="email"
                                value={newCandidat.email}
                                onChange={handleChange}
                                placeholder="sur-un-malentendu@onsaitjamais.fr"
                            />
                        </Form.Group>
                        <Form.Group controlId="formTypePoste">
                            <Form.Label>Poste</Form.Label>
                            <Form.Control
                                as="select"
                                name="typePosteId"
                                value={newCandidat.typePosteId}
                                onChange={handleChange}
                            >
                                <option value="">--</option>
                                {typesPoste.map(type => (
                                    <option key={type.id} value={type.id}>
                                        {type.titre}
                                    </option>
                                ))}
                            </Form.Control>
                        </Form.Group>
                        <Form.Group controlId="formNiveau">
                            <Form.Label>Niveau</Form.Label>
                            <Form.Control
                                as="select"
                                name="niveauId"
                                value={newCandidat.niveauId}
                                onChange={handleChange}
                            >
                                <option value="">--</option>
                                {niveaux.map(niveau => (
                                    <option key={niveau.id} value={niveau.id}>
                                        {niveau.titre}
                                    </option>
                                ))}
                            </Form.Control>
                        </Form.Group>
                        <Form.Group controlId="formQuiz">
                            <Form.Label>Quiz</Form.Label>
                            <Form.Control
                                as="select"
                                name="quizId"
                                value={newCandidat.quizId}
                                onChange={handleChange}
                            >
                                <option value="">--</option>
                                {quizzes.map(quiz => (
                                    <option key={quiz.id} value={quiz.id}>
                                        {quiz.titre}
                                    </option>
                                ))}
                            </Form.Control>
                        </Form.Group>
                    </Form>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={handleCloseModal}>
                        Close
                    </Button>
                    <Button variant="primary" onClick={handleSave}>
                        Save Changes
                    </Button>
                </Modal.Footer>
            </Modal>
        </div>
    );
};

export default AdminCandidats;
