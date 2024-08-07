
// eslint-disable-next-line no-unused-vars
import React from 'react';
import { Nav, Navbar } from 'react-bootstrap';

const AdminMenu = ({ currentSection, onSectionChange }) => {
    return (
        <Navbar bg="light" expand="lg" className={"flex-column"}>
            <Navbar.Brand>Menu</Navbar.Brand>
            <Navbar.Toggle aria-controls="admin-navbar-nav" />
            <Navbar.Collapse id="admin-navbar-nav">
                <Nav className="mr-auto flex-column">
                    <Nav.Link
                        active={currentSection === 'dashboard'}
                        onClick={() => onSectionChange('dashboard')}
                    >
                        Dashboard
                    </Nav.Link>
                    <Nav.Link
                        active={currentSection === 'candidats'}
                        onClick={() => onSectionChange('candidats')}
                    >
                        Candidats
                    </Nav.Link>
                    <Nav.Link
                        active={currentSection === 'quizzes'}
                        onClick={() => onSectionChange('quizzes')}
                    >
                        Quizzes
                    </Nav.Link>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    );
};

export default AdminMenu;
