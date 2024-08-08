import React, {useState} from 'react';
import {Form, Button, Container, Row, Col, Fade} from 'react-bootstrap';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faChevronRight} from "@fortawesome/free-solid-svg-icons";
import apiCandidat from '../services/apiCandidat';

const Login = ({handleCandidat}) => {
    const [candidat, setCandidat] = useState({
        prenom: '',
        nom: '',
        email: ''
    });

    const handleChange = (e) => {
        const {id, value} = e.target;
        setCandidat({
            ...candidat,
            [id]: value
        });
    };

    const isFormComplete = () => {
        return candidat.prenom !== '' && candidat.nom !== '' && candidat.email !== '';
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        if (isFormComplete()) {
            handleCandidat(candidat);
            try {
                const dataToSend = {
                    ...candidat,
                    adminDashboard: false
                }
                await apiCandidat.submitCandidat(dataToSend);
                console.log('Success!');
            } catch (error) {
                console.error('Error:', error);
                console.log('nope!');
            }
        }
    };

    return (
        <Container className="mt-5 center">
            <h2 className="mb-4">Login</h2>
            <p>
                Bienvenue sur notre plateforme de tests technique. Votre profil a su attirer notre attention et nous
                souhaiterions vous connaitre un peu plus.<br/>
                Afin de vous offrir une expérience adaptée, veuillez renseigner ces champs avant de passer à la suite.
            </p>
            <Form onSubmit={handleSubmit}>
                <Row className="mb-3">
                    <Col>
                        <Form.Group controlId="prenom">
                            <Form.Control
                                type="text"
                                placeholder="Prénom"
                                value={candidat.prenom}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>
                    </Col>
                    <Col>
                        <Form.Group controlId="nom">
                            <Form.Control
                                type="text"
                                placeholder="Nom"
                                value={candidat.nom}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>
                    </Col>
                </Row>
                <Row>
                    <Col>
                        <Form.Group className="mb-3" controlId="email">
                            <Form.Control
                                type="email"
                                placeholder="Email"
                                value={candidat.email}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>
                    </Col>
                    <Col className="d-flex justify-content-end">
                        <Fade in={isFormComplete()}>
                            <div>
                                <Button variant="primary" type="submit">
                                    Let's go!&nbsp;
                                    <FontAwesomeIcon icon={faChevronRight}/>
                                </Button>
                            </div>
                        </Fade>
                    </Col>
                </Row>
            </Form>
        </Container>
    );
};

export default Login;