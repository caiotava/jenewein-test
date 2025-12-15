import {NavLink} from "react-router-dom";

type Props = {
    page: string;
};

const Link = ({page}: Props) => {
    const pageHref = `/${page.toLowerCase()}`;

    return (
        <NavLink
            to={pageHref}
            className={({isActive}) =>
                isActive
                    ? "bg-rose-100"
                    : "transition duration-500 hover:bg-gray-100"
            }
        >
            {page}
        </NavLink>
    );
};

export default Link;
