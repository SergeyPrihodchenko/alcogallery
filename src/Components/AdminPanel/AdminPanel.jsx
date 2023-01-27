import { Button, Slide, Snackbar, TextField } from "@mui/material";
import { useState } from "react";


  

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
    const handleChangeFile = (e) => {
        const file = e.target.files[0];
        setValueFile(file);
        setValueFileInput(file.name);
    }

    const handleChangeName = (e) => {
        setValueName(e.target.value);
    }

    const handleChangeDescription = (e) => {
        setValueDescription(e.target.value);
    }
  
    const sendData = async () => {
        
        const formData = new FormData();
        formData.append('img_file', valueFile);

        const data = {
            name: valueName,
            description: valueDescription,
            img_name: valueFile.name
        }
        
        const response = await fetch('./backEnd/index.php', {
            method: 'POST',
            headers: {
                'ACTION': 'SAVE_IMG_FILE'
            },
            body: formData
        })

        let result = await response.json();

        if(result.success) {

            
            const response = await fetch('./backEnd/index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'aplication/json',
                    'ACTION': 'SAVE_CONTENT_DATA'
                },
                body: JSON.stringify(data)
            });

            result = await response.json();
        }
        if(await result.success) {
            setColorAlert('rgb(114, 243, 138)');
            setValueAlert('Добавленно!');
            handleClick(TransitionRight);
            setValueName('');
            setValueFileInput('Выберите файл');
            setValueDescription('');
        } else {
            handleClick(TransitionRight);
            setValueName('');
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
                        margin: '10px'
                    }}/>
                    <div className="blockFile">
                        <label className="input-file">
                            <input onChange={handleChangeFile} type="file" name="img_file"/>	
                            <span>{valueFileInput}</span>
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
                        margin: '10px'
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