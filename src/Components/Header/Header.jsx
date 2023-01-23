import { useState } from "react";
import { Link } from "react-router-dom";
import { getCoockie } from "../../functions/function";
import LinkAdminPanel from "../AdminPanel/LinkAdminPanel";
import Logout from "./Logout";
import SignIn from "./SignIn";

const Header = () => {

    let cookieToken = getCoockie('TokenSet');

    const [token, setToken] = useState(cookieToken);


    return (
        <div className="header_nav">
            <Link to={'/'}><h1 className="header_login">Шота у ашота!</h1></Link>
            {token === false ? null : <LinkAdminPanel/>}
            {token === false ? <SignIn/> : <Logout/>}
        </div>
    );
}

export default Header;