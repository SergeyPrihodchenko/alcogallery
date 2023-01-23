import AdminPanelSettingsIcon from '@mui/icons-material/AdminPanelSettings';
import { Link } from 'react-router-dom';

const LinkAdminPanel = () => {
    return (
        <Link to={'adminPanel'}><AdminPanelSettingsIcon/></Link>
    );
}

export default LinkAdminPanel;