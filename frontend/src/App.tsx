import './App.css'
import {Routes, Route} from "react-router-dom";
import NavBar from "@/components/navBar";
import PageType from "@/shared/PageType";
import {RequireAuth} from "@/api/auth";
import {CoursesPage, LoginPage, LogoutPage} from "@/pages";

function App() {
    return (
        <>
            <div className="app">
                <NavBar/>
                <main className="main mt-10">
                    <Routes>
                        <Route path="/login" element={<LoginPage/>}/>

                        <Route element={<RequireAuth roles={["ROLE_USER", "ROLE_ADMIN"]}/>}>
                            <Route path={`/${PageType.Courses}`} element={<CoursesPage/>}/>
                            <Route path={`/${PageType.Organizations}`} element={<CoursesPage/>}/>
                            <Route path={`/${PageType.Users}`} element={<CoursesPage/>}/>
                            <Route path={`/${PageType.Logout}`} element={<LogoutPage/>}/>
                        </Route>
                    </Routes>
                </main>
            </div>
        </>
    )
}

export default App
