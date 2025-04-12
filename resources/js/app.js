import './bootstrap';
import Dashboard from './dashboard';
import InfiniteScrolling  from './infinite-scrolling';

document.addEventListener('DOMContentLoaded', () => {
    Dashboard.init()
    InfiniteScrolling.init()
})