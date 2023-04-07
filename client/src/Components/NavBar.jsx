import { NavLink } from 'react-router-dom'

function NavBar() {
  return (
    <nav className="navbar navbar-expand-lg navbar-light bg-light">
      <a className="navbar-brand" to="/">My Blog</a>
      <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span className="navbar-toggler-icon"></span>
      </button>
      <div className="collapse navbar-collapse" id="navbarNav">
        <ul className="navbar-nav mr-auto">
          <li className="nav-item">
            <a className="nav-link" to="/">posts</a>
          </li>
          <li className="nav-item">
            <a className="nav-link" to="/about">categories</a>
          </li>
          <li className="nav-item">
            <a className="nav-link" href="/contact">users</a>
          </li>
        </ul>
        <a className="nav-link" href="/add-post">Add Post</a>
      </div>
    </nav>
  );
}
export default NavBar;