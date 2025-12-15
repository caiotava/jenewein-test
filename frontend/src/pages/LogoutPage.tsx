import {Navigate} from "react-router-dom";
import {logout} from "@/api/userAuth"

const LogoutPage = () => {
    logout();
    return <Navigate to="/login" replace/>;
};

export default LogoutPage;
