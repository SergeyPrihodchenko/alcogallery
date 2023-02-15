import { CONTENT_RENDER } from "./action";

const initialState = {contentData: 10};

const contentReducer = (state = initialState, action) => {
    switch (action.type) {
        case CONTENT_RENDER:
            console.log('test');
            return {
                ...state,
                contentData: action.payload.contentData
            }
        default:
            return state;
    }
}

export default contentReducer;