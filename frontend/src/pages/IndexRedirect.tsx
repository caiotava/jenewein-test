import { Navigate } from "react-router-dom";
import { userAuth} from "@/api/userAuth";

export default function IndexRedirect() {
    const {isAuthenticated} = userAuth();
    if (!isAuthenticated) {
        return <Navigate to="/login" replace />;
    }

    return <Navigate to="/courses" replace />;
}
