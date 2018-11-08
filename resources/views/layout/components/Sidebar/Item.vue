<script>
export default {
  name: "MenuItem",
  functional: true,
  props: {
    icon: {
      type: String,
      default: ""
    },
    title: {
      type: String,
      default: ""
    }
  },
  render(h, context) {
    const { icon, title } = context.props;
    const vnodes = [];

    if (icon) {
      vnodes.push(
        h("i", {
          attrs: { class: `fas fa-${icon} `, style: "margin-right: 16px;" }
        })
      );
    }

    if (title) {
      vnodes.push(h("span", title));
    }
    return vnodes;
  }
};
</script>
