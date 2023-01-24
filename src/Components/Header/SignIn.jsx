import LoginIcon from '@mui/icons-material/Login';
import { useState } from 'react';
import AuthForm from '../Authentication/AuthForm';
import PropTypes from 'prop-types';


const SignIn = () => {

    AuthForm.propTypes = {
        onClose: PropTypes.func.isRequired,
        open: PropTypes.bool.isRequired,
        selectedValue: PropTypes.string.isRequired,
      };


    const [open, setOpen] = useState(false);

    const handleClickOpen = () => {
        setOpen(true);
      };

    const handleClose = (value) => {
        setOpen(false);
    };

    return (
        <>
            <LoginIcon className='action_icon' fontSize='large' onClick={handleClickOpen} />
            <AuthForm
                open={open}
                onClose={handleClose}
            />
        </>
    );
}

export default SignIn;