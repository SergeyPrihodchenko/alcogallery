export const CONTENT_RENDER = "CONTENT::RENDER";

export const actionRender = (data) => {
    return {type: CONTENT_RENDER,
    payload: {
        contentData: data
    }}
};

export const actionRenderThunk = () => async (dispatch) => {
    const response = await fetch('./backEnd/index.php', {
        method: 'POST',
        headers: {
            'ACTION': 'GET_CONTENT'
        }
    })
    const result = await response.json();
    dispatch(actionRender(result.data.contents));
}