import { Button, Slide, Snackbar, TextField } from "@mui/material";
import { useState } from "react";
import { sendFileData } from "../../functions/function";


  

const AdminPanel = () => {

    function TransitionRight(props) {
        return <Slide {...props} direction="right" style={{color: colorAlert}}/>;
      }

    const [open, setOpen] = useState(false);
    const [transition, setTransition] = useState(undefined);

    const handleClick = (Transition) => {
        setTransition(() => Transition);
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const [valueFileInput, setValueFileInput] = useState('Выберите файл');
    const [valueFile, setValueFile] = useState('');
    const [valueName, setValueName] = useState('');
    const [valueDescription, setValueDescription] = useState('');
    const [colorAlert, setColorAlert] = useState('red');
    const [valueAlert, setValueAlert] = useState('Ошибка при добавлении!');
    const [backgroundDescription, setBackgroundDescription] = useState('');
    const [backgroundInput, setBackgroundInput] = useState('');
    const [backgroundFileInp, setBackgroundFileInp] = useState('');

    const handleChangeFile = (e) => {
        const file = e.target.files[0];
        setValueFile(file);
        setValueFileInput(file.name);
        setBackgroundFileInp('')
    }

    const handleChangeName = (e) => {
        setValueName(e.target.value);
        setBackgroundInput('');
    }

    const handleChangeDescription = (e) => {
        setValueDescription(e.target.value);
        setBackgroundDescription('');
    }
  
    const sendData = async () => {

        if(valueFile.length === 0 || valueName.length === 0 || valueDescription === 0) {
            setBackgroundDescription('#f88b8b');
            setBackgroundInput('#f88b8b');
            setBackgroundFileInp('#f88b8b');
            return;
        }
        
        let result = await sendFileData(valueFile, valueName, valueDescription);

        if(await result.success) {
            setColorAlert("rgb(114, 243, 138)");
            setValueAlert('Добавленно!');
            handleClick(TransitionRight);
            setValueName('');
            setValueFileInput('Выберите файл');
            setValueDescription('');
        } else {
            handleClick(TransitionRight);
            setValueName('');
            setValueFile([]);
            setValueFileInput('Выберите файл');
            setValueDescription('');
            return result.success;
        }
    }

    return (
        <div className="container">
            <div className="formBlock">
                <div className="namefile">
                    <TextField id="outlined-basic" label="Название" variant="outlined" onChange={handleChangeName} value={valueName} style={{
                        margin: '10px',
                        backgroundColor: backgroundInput
                    }}/>
                    <div className="blockFile">
                        <label className="input-file">
                            <input onChange={handleChangeFile} type="file" name="img_file"/>	
                            <span style={{backgroundColor: backgroundFileInp}}>{valueFileInput}</span>
                        </label>
                    </div>
                </div>
                <TextField
                    id="outlined-multiline-static"
                    label="Описание"
                    value={valueDescription}
                    onChange={handleChangeDescription}
                    multiline
                    rows={8}
                    style={{
                        maxWidth: '350px',
                        width: '100%',
                        margin: '10px',
                        backgroundColor: backgroundDescription
                    }}
                />
                <div className="">
                    <Button variant="contained" onClick={sendData} style={{
                        margin: '10px'
                    }}>Добавить</Button>
                </div>
            </div>
            <Snackbar
            open={open}
            onClose={handleClose}
            TransitionComponent={transition}
            message={valueAlert}
            key={transition ? transition.name : ''}
            />
        </div>
    );
}

export default AdminPanel;