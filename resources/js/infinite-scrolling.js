const init = () => {
    document.querySelectorAll('.infinite-scrolling').forEach(element => {
        initElement(element)

    })
}

const initElement = (element) => {
    const loadingIndicator = createLoadingIndicator(element)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                console.log('amogus')
                loadContent(loadingIndicator, observer)
            }
        })
    }, {
        threshold: 0,
        root: null
    })
    observer.observe(loadingIndicator)
}

const createLoadingIndicator = (element) => {
    const indicator = document.createElement('div')
    indicator.className = 'loading'
    indicator.innerText="Loading..."
    indicator.setAttribute('data-page', 2)
    element.appendChild(indicator)
    return indicator
}

const loadContent = (element, observer) => {
    const page = element.getAttribute('data-page')
    if (page === '0') {
        return
    }
    const url = window.location.href
    fetch(`${url}?page=${page}`)
        .then(response => response.text())
        .then(html => {
            if (html === '') {
                element.remove()
                observer.disconnect()
                return
            }
            element.insertAdjacentHTML('beforebegin', html)
            element.setAttribute('data-page', parseInt(page) + 1)
        })
        .catch(error => console.log(error))
}

export default { init }