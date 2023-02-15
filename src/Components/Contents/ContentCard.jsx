const ContentCard = (props) => {
    console.log(props.data.description);
    return (
        <div>
            <h3>{props.data.name}</h3>
            <img src={"/imgs/" + props.data.img_name} alt="not_imgs"/>
            <p>{props.data.description}</p>
        </div>
    );
}

export default ContentCard;