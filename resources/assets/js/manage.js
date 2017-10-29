/**
 * Created by on 29-Oct-17.
 */

const accordions = document.getElementsByClassName('has-submenu')

for (let i = 0; i < accordions.length; i++) {
  accordions[i].onclick = function () {
    this.classList.toggle('is-active');

    const submenu = this.nextElementSibling;

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

