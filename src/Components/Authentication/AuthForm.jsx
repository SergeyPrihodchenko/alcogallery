import DialogTitle from '@mui/material/DialogTitle';
import Dialog from '@mui/material/Dialog';
import { Button, TextField } from '@mui/material';
import { useState } from 'react';
import { authSend } from '../../functions/function';


const AuthForm = (props) => {


    const { onClose, selectedValue, open } = props;
      
    const handleClose = () => {
      onClose(selectedValue);
    }
    const [nickValue, setNickValue] = useState('');
    const [passValue, setPassValue] = useState('');

    const handleChangeNick = (e) => {
        setNickValue(e.target.value);
    }
    const handleChangePass = (e) => {
        setPassValue(e.target.value);
    }

    const send = () => {

        if(nickValue === '' || passValue === '') {
            return;
        }

        const result  = authSend(nickValue, passValue);

        setNickValue('');
        setPassValue('');
        handleClose();
    }

    return (
        <>
        <Dialog className='dialogAuth' onClose={handleClose} open={open}>
        <DialogTitle style={{
            fontWeight: '600'
        }} className='dialogTitle'>Authentication</DialogTitle>
        <TextField style={{
            padding: '10px'
        }} className='inputAuth' id="filled-basic" label="nickName" variant="filled" value={nickValue} onChange={handleChangeNick}/>
        <TextField type="password" style={{
            padding: '10px'
        }} className='inputAuth' id="filled-basic" label="password" variant="filled" value={passValue} onChange={handleChangePass}/>
        <div className='authBtn'>
            <Button style={{
            padding: '10px'
        }} onClick={send}>Sign in</Button>
        </div>
        </Dialog>
        </>
    );
}
export default AuthForm;