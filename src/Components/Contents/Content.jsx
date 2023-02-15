import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { actionRenderThunk } from "../../store/action";
import ContentCard from "./ContentCard";

const Content = () => {
    const contents = useSelector(state => state.content);

    const dispatch = useDispatch();

    const requestContent =  () => {
       dispatch(actionRenderThunk(dispatch));
    }

    useEffect(() => {requestContent()}, []);

    return (
            <div className="container">
                {Array.isArray(contents.contentData) ? contents.contentData.map(el => {return <ContentCard data={el}/>}) : null}
            </div>
    );
}

export default Content;