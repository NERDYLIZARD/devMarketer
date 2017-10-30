/**
 * Created by on 29-Oct-17.
 */

const accordions = document.querySelectorAll('.has-submenu')
const adminSlideButton = document.querySelector('#admin-slideout-button')


adminSlideButton.onclick = function () {
  this.classList.toggle('is-active')
  document.querySelector('#admin-side-menu').classList.toggle('is-active')
}


accordions.forEach(accordion => {
  // if class main menu is active, open class menu onload
  if (accordion.classList.contains('is-active')) {
    const submenu = accordion.nextElementSibling
    submenu.style.maxHeight = submenu.scrollHeight + 'px'
    submenu.style.margin = '.75em'
  }

  accordion.onclick = function () {
    this.classList.toggle('is-active')

    const submenu = this.nextElementSibling

    if (submenu.style.maxHeight) {
      // menu is open, need to be closed
      submenu.style.maxHeight = null
      submenu.style.margin = null
    }
    else {
      // menu is closed, open it
      submenu.style.maxHeight = submenu.scrollHeight + 'px'
      submenu.style.margin = '.75em'
    }
  }

})

