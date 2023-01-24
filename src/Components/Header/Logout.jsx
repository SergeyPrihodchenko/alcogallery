import LogoutIcon from '@mui/icons-material/Logout';
import { getCoockie } from '../../functions/function';
const Logout = ({setToken}) => {

    const logout = async () => {
        const response = await fetch('./backEnd/index.php', {
            method: 'POST',
            headers: {
                'ACTION': 'LOGOUT'
            },
            body: JSON.stringify({'TokenSet': getCoockie('TokenSet')})
        })
        const result = await response.json();
        setToken(false);
        console.log(result['result']);
    }
    return (
        <LogoutIcon onClick={logout} className='action_icon'/>
    );
}

export default Logout;