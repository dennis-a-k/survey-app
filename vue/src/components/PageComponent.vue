<template>
  <span>
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
    </header>

    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <slot name="main"></slot>
      </div>
    </main>
  </span>
</template>

<script>
export default {
  name: "PageComponent",
};
</script>
