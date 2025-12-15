import {Navigate, Outlet, useLocation} from "react-router-dom";
import type {FC} from "react";
import {userAuth} from "@/api/userAuth";

type Props = {
    roles?: string[];
};

export const RequireAuth: FC<Props> = ({roles}) => {
    const {isAuthenticated, userRoles} = userAuth();
    const location = useLocation();

    if (!isAuthenticated) {
        return <Navigate to="/login" state={{from: location}} replace/>;
    }

    if (roles && !roles.some(role => userRoles?.includes(role))) {
        return <Navigate to="/unauthorized" replace/>;
    }

    return <Outlet/>;
};
