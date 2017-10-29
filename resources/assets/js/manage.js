/**
 * Created by on 29-Oct-17.
 */

const accordions = document.getElementsByClassName('has-submenu')

for (let i = 0; i < accordions.length; i++) {

  // if class main menu is active, open class menu onload
  if (accordions[i].classList.contains('is-active')) {
    const submenu = accordions[i].nextElementSibling
    submenu.style.maxHeight = submenu.scrollHeight + 'px'
    submenu.style.margin = '.75em'
  }

  accordions[i].onclick = function () {
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

}

