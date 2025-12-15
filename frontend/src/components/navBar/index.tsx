import Link from "@/components/navBar/link";
import {userAuth} from "@/api/userAuth";
import {useEffect, useState} from "react";

const NavBar = () => {
    const [, forceUpdate] = useState(0);

    useEffect(() => {
        const rerender = () => forceUpdate(v => v + 1);
        window.addEventListener("auth-change", rerender);

        return () => {
            window.removeEventListener("auth-change", rerender);
        };
    }, []);

    const flexItemsClass = "flex items-center justify-between"
    const {isAdmin} = userAuth();

    return (
        <nav>
            <div className={`${flexItemsClass} fixed top-0 z-30 w-full py-6 bg-gray-50`}>
                <div className={`${flexItemsClass} mx-auto w-5/6`}>
                    <div className={`${flexItemsClass} gap-8 text-xl font-semibold`}>
                        <Link page="Courses"/>

                        {isAdmin && (
                            <>
                                <Link page="Organizations"/>
                                <Link page="Users"/>
                            </>
                        )}

                        <Link page="Logout"/>
                    </div>
                </div>
            </div>
        </nav>
    )
}

export default NavBar;
