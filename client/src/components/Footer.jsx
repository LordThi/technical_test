import React from "react";

const Footer = ({companyName}) => {

    const year = new Date().getFullYear()
    ;
    return (
        <div className="d-flex flex-row justify-content-center align-items-lg-end"
             style={{
                 position: 'absolute',
                 left: 0,
                 bottom: 0,
                 right: 0,
             }}>
            <p>{companyName ? companyName : 'Tout droits réservés'}&nbsp;-&nbsp;</p>
            <p>{year}</p>
        </div>
    );
};

export default Footer;