import {useNavigate} from "react-router-dom";

type Props = {
    id: number,
    name: string,
    description: string,
};

const CourseCard = ({id, name, description}: Props) => {
    const navigate = useNavigate();

    return (
        <div
            key={id}
            onClick={() => navigate(`/courses/${id}`)}
            className="
                    bg-white
                    rounded-xl
                    border
                    border-gray-200
                    p-5
                    shadow-sm
                    transition
                    hover:shadow-lg
                    hover:bg-rose-50
                    cursor-pointer
            "
        >
            <h2 className="font-bold text-lg text-gray-800">
                {name}
            </h2>
            <div className="text-base text-gray-700">{description}</div>
        </div>
    )
}

export default CourseCard;
