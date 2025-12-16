type Props = {
    page: number
    totalPages: number
    onPageChange: (page: number) => void
};

const Pagination = ({page, totalPages, onPageChange}: Props) => {
    return (
        <footer className="flex items-center justify-center gap-4 mt-8">
            <button
                disabled={page === 1}
                onClick={() => onPageChange(page - 1)}
                className="px-4 py-2 border rounded disabled:opacity-50"
            >
                Previous
            </button>

            <span>Page {page} of {totalPages}</span>

            <button
                disabled={page >= totalPages}
                onClick={() => onPageChange(page + 1)}
                className="px-4 py-2 border rounded disabled:opacity-50"
            >
                Next
            </button>
        </footer>
    );
}

export default Pagination;
