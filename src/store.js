import { applyMiddleware, combineReducers, createStore } from "redux";
import thunk from "redux-thunk";
import contentReducer from "./store/reducer";

const store = createStore(combineReducers({
    content: contentReducer
}), applyMiddleware(thunk));

export default store;