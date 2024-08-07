import { useState, useEffect } from 'react';
import axios from 'axios';
import { Form, Button, Col, Row } from 'react-bootstrap';

const QuestionForm = ({ questionId }) => {
    const [question, setQuestion] = useState({
        texteQuestion: '',
        difficulteId: 1,
        quizId: 1,
        themeIds: [], // Changed to an array for multiple themes
        typeId: 1
    });

    const [isNew, setIsNew] = useState(true);

    const [difficultes, setDifficultes] = useState([]);
    const [quizzes, setQuizzes] = useState([]);
    const [themes, setThemes] = useState([]);
    const [types, setTypes] = useState([]);

    useEffect(() => {
        // Fetch the available options
        axios.get('/api/difficultes')
            .then(response => setDifficultes(response.data))
            .catch(error => console.error('Error fetching difficulties:', error));

        axios.get('/api/quizzes')
            .then(response => setQuizzes(response.data))
            .catch(error => console.error('Error fetching quizzes:', error));

        axios.get('/api/questions_themes')
            .then(response => setThemes(response.data))
            .catch(error => console.error('Error fetching themes:', error));

        axios.get('/api/questions_types')
            .then(response => setTypes(response.data))
            .catch(error => console.error('Error fetching types:', error));

        // If questionId is provided, fetch the question data
        if (questionId) {
            axios.get(`/api/questions/${questionId}`)
                .then(response => {
                    setQuestion(response.data);
                    setIsNew(false);
                })
                .catch(error => console.error('Error fetching question:', error));
        }
    }, [questionId]);

    const handleChange = (event) => {
        const { name, value, type, checked } = event.target;

        if (type === 'checkbox') {
            setQuestion(prev => {
                const updatedThemeIds = checked
                    ? [...prev.themeIds, value]
                    : prev.themeIds.filter(id => id !== value);

                return { ...prev, themeIds: updatedThemeIds };
            });
        } else {
            setQuestion(prev => ({ ...prev, [name]: value }));
        }
    };

    const handleSubmit = (event) => {
        event.preventDefault();

        const method = isNew ? 'POST' : 'PUT';
        const url = isNew ? '/api/questions' : `/api/questions/${questionId}`;

        axios({ method, url, data: question })
            .then(response => {
                console.log('Question saved:', response.data);
                // Redirection ou message de succès
            })
            .catch(error => console.error('Error:', error));
    };

    return (
        <Form onSubmit={handleSubmit}>
            <Form.Group as={Row} controlId="formQuestionText">
                <Form.Label column sm={2}>
                    Texte de la question:
                </Form.Label>
                <Col sm={10}>
                    <Form.Control
                        type="text"
                        name="texteQuestion"
                        value={question.texteQuestion}
                        onChange={handleChange}
                        placeholder="Entrez le texte de la question"
                    />
                </Col>
            </Form.Group>

            <Form.Group as={Row} controlId="formDifficulte">
                <Form.Label column sm={2}>
                    Difficulté:
                </Form.Label>
                <Col sm={10}>
                    <Form.Control
                        as="select"
                        name="difficulteId"
                        value={question.difficulteId}
                        onChange={handleChange}
                    >
                        {difficultes.map(difficulte => (
                            <option key={difficulte.id} value={difficulte.id}>
                                {difficulte.titre}
                            </option>
                        ))}
                    </Form.Control>
                </Col>
            </Form.Group>

            <Form.Group as={Row} controlId="formQuiz">
                <Form.Label column sm={2}>
                    Quiz:
                </Form.Label>
                <Col sm={10}>
                    <Form.Control
                        as="select"
                        name="quizId"
                        value={question.quizId}
                        onChange={handleChange}
                    >
                        {quizzes.map(quiz => (
                            <option key={quiz.id} value={quiz.id}>
                                {quiz.titre}
                            </option>
                        ))}
                    </Form.Control>
                </Col>
            </Form.Group>

            <Form.Group as={Row} controlId="formTheme">
                <Form.Label column sm={2}>
                    Thème:
                </Form.Label>
                <Col sm={10}>
                    {themes.map(theme => (
                        <Form.Check
                            key={theme.id}
                            type="checkbox"
                            label={theme.titre}
                            value={theme.id}
                            checked={question.themeIds.includes(theme.id.toString())}
                            onChange={handleChange}
                        />
                    ))}
                </Col>
            </Form.Group>

            <Form.Group as={Row} controlId="formType">
                <Form.Label column sm={2}>
                    Type:
                </Form.Label>
                <Col sm={10}>
                    <Form.Control
                        as="select"
                        name="typeId"
                        value={question.typeId}
                        onChange={handleChange}
                    >
                        {types.map(type => (
                            <option key={type.id} value={type.id}>
                                {type.titre}
                            </option>
                        ))}
                    </Form.Control>
                </Col>
            </Form.Group>

            <Form.Group as={Row}>
                <Col sm={{ span: 10, offset: 2 }}>
                    <Button variant="primary" type="submit">
                        Sauvegarder
                    </Button>
                </Col>
            </Form.Group>
        </Form>
    );
};

export default QuestionForm;
