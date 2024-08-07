// src/components/Dashboard.jsx
import React, { useState } from 'react';
import { Container } from 'react-bootstrap';
import AdminMenu from './AdminMenu.jsx';
import QuizForm from '../Form/QuizForm.jsx';
import QuestionForm from '../Form/QuestionForm.jsx';

const Dashboard = () => {
    const [currentSection, setCurrentSection] = useState('dashboard');

    const renderContent = () => {
        switch (currentSection) {
            case 'quizzes':
                return <QuizForm />;
            case 'questions':
                return <QuestionForm />;
            default:
                return (
                    <Container className="mt-4">
                        <h1>Welcome to the Dashboard</h1>
                        <p>Select a section from the menu to start.</p>
                    </Container>
                );
        }
    };

    return (
        <div className={"d-flex flex-row"} style={{height: '100%' }}>
            <div className="admin_menu">
                <AdminMenu currentSection={currentSection} onSectionChange={setCurrentSection} />
            </div>
            {renderContent()}
        </div>
    );
};

export default Dashboard;
