import { createVNode, render } from 'vue'
import Loader from '../../views/components/Loader.vue'

export default {
  install(app) {
    const container = document.createElement('div')
    document.body.appendChild(container)

    const vnode = createVNode(Loader)
    render(vnode, container)

    const instance = vnode.component.proxy

    app.config.globalProperties.$loader = {
      presentLoader() {
        instance.show()
      },
      dismissLoader() {
        instance.hide()
      }
    }
  }
}
