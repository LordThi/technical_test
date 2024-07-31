import React, {useEffect, useState} from "react";
import {Container, Fade} from "react-bootstrap";
import {faChevronRight} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

const Instructions = ({companyName, candidat}) => {
    const [showArrow, setShowArrow] = useState(false);
    const [etat, setEtat] = useState('greetings');

    useEffect(() => {
        // Déclencher l'affichage de la flèche après 3 secondes
        const timer = setTimeout(() => {
            setShowArrow(true);
        }, 5000);

        // Nettoyer le timer lors du démontage du composant
        return () => clearTimeout(timer);
    }, [etat]);


    const handleClick = () => {
        if (etat === 'greetings') {
            setEtat('instructions');
            setShowArrow(false)
        }
    };

    const greetings = <Container className="mt-5 center">
        <h2 className="mb-4">Bienvenue {candidat.firstname},</h2>
        <p>
            Chez {companyName || 'nous'}, nous accordons autant d'importance au candidat qu'à son savoir faire
            technique.
        </p>
        <p>
            On ne cherche pas à éliminer nos candidats sur un test de code qu'on appliquera jamais dans notre
            quotidien. Aucun stress à avoir, cela nous permet de te connaitre un peu plus et fixe une base sur
            laquelle travailler.
        </p>
        <Fade in={showArrow}>
            <div className="text-center mt-3">
                <FontAwesomeIcon icon={faChevronRight} size="2x" onClick={handleClick}
                                 style={{cursor: "pointer"}}/>
            </div>
        </Fade>
    </Container>

    const instructions = <Container>
        <h2 className="mb-4">Instructions</h2>
        <p>
            Tu vas avoir un délai de -- pour répondre au maximum de questions possibles.
        </p>
        <p>Toutes les questions sont de différents niveaux et apparaissent de façon aléatoire. Si tu n'as pas su
            répondre à une question, pas de panique, d'autres les rattraperont.
        </p>
        <p>
            Le questionnaire est composé d'un QCM avec échelle de confiance (parce qu'on les connait les chanceux qui
            passent à travers les gouttes.
        </p>
        <p>image</p>
        <p>
            Il y a 5 niveaux de certitude:
            <ul className="d-flex flex-row justify-content-around">
                <li>0%</li>
                <li>25%</li>
                <li>50%</li>
                <li>75%</li>
                <li>100%</li>
            </ul>
        </p>
        <p>
            En fonction de ta confiance en toi, tu pourras gagner 1 pt, 0.75 pts ou 0.25 pts. En revanche, si tu te
            plantes, tu perds autant de points 😅...<br/>
            Encore une fois, rien d'éliminatoire, mais cela nous permettra d'en discuter lors du débrief.gy
        </p>
        <Fade in={showArrow}>
            <button
                className="text-center mt-3 d-flex flex-row "
                onClick={handleClick}
                style={{
                    backgroundColor: 'transparent',
                    border: 'none',
                    color: 'black'
                }}
            >
                <p className="align-self-center m-auto p-1">Zéééé Parti!</p>
                <FontAwesomeIcon
                    icon={faChevronRight}
                    size="2x"

                    style={{cursor: "pointer"}}/>
            </button>
        </Fade>
    </Container>


    return (
        <>
            {etat == 'greetings' && greetings}
            {etat == 'instructions' && instructions}
        </>

    )
};

export default Instructions;