import React, {useState} from 'react';
import {Form, Button, Container, Row, Col, Fade} from 'react-bootstrap';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faChevronRight} from "@fortawesome/free-solid-svg-icons";

const Login = ({handleCandidat}) => {
    const [candidat, setCandidat] = useState({
        firstname: '',
        lastname: '',
        mail: ''
    })

    const handleSubmit = (event) => {
        event.preventDefault();
        handleCandidat(candidat);
    };

    const isFormComplete = () => {
        return candidat.firstname !== '' && candidat.lastname !== '' && candidat.mail !== '';
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
                        <Form.Group controlId="firstname">
                            <Form.Control
                                type="text"
                                placeholder="Prénom"
                                value={candidat.firstname}
                                onChange={(e) => setCandidat({...candidat, firstname: e.target.value})}
                                required
                            />
                        </Form.Group>
                    </Col>
                    <Col>
                        <Form.Group controlId="lastname">
                            <Form.Control
                                type="text"
                                placeholder="Nom"
                                value={candidat.lastname}
                                onChange={(e) => setCandidat({...candidat, lastname: e.target.value})}
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
                                value={candidat.mail}
                                onChange={(e) => setCandidat({...candidat, mail: e.target.value})}
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