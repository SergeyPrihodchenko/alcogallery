import { useState } from "react";
import { getCoockie } from "../../functions/function";

const ContentCard = (props) => {
    const [token, setToken] = useState(getCoockie('TokenSet'));
    const deleteCard = async (e) => {
        const data = {id_post: e.target.dataset.id}
        const response = await fetch('./backEnd/index.php', {
            method: 'POST',
            headers: {
                ACTION: 'DELETE_POST'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        console.log(result);
    }

    return (
        <div key={props.data.id} className="content_card">
            <h3 key={props.data.id} className="drink_name">{props.data.name}</h3>
            <img key={props.data.id} className="drink_img" src={"/imgs/" + props.data.img_name} alt="no imgs"/>
            <p key={props.data.id} className="drink_description" dangerouslySetInnerHTML={{__html:props.data.description}}></p>
            {token === false ? null : <span onClick={deleteCard} key={props.data.id} data-id={props.data.id} className="close"></span>}
        </div>
    );
}

export default ContentCard;