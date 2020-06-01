const fs = require('fs'),path = require('path');
const chalk = require('chalk');
const prefix = "SB";
const modulesPath = 'src/modules';
const args = process.argv.slice(2);

const error = (...args) => {
  console.log(chalk.red(...args));
};

const success = (...args) => {
  console.log(chalk.green(...args));
};

if (!args.length) {
  error('You must provide a name for the module!');
  return;
}

const moduleName = args[0];
const modulePath = path.join(__dirname, modulesPath, moduleName);
const storePath = path.join(__dirname, modulesPath, moduleName, 'store');

if (fs.existsSync(modulePath)) {
  error(`${moduleName} directory already exists!`);
  return;
}

String.prototype.capitalize = function() {
  let cebab = this.charAt(0).toUpperCase() + this.slice(1);
  return cebab.replace(/-([a-z])/g, function (g) { return g[1].toUpperCase(); });
};

String.prototype.kebab = function() {
  return this.replace(/-([a-z])/g, function (g) {
    return g[1].toUpperCase();
  });
};

const stateContent = `import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
`;
const exportFileContent = `export default {};`;

const vueFileContent = `<template>
  <div>${moduleName}</div>
</template>

<script>
  import localMixin from './localMixin';
  export default {
    name: "${prefix}${moduleName.capitalize()}",
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
`;

const mixinContent = `import ${moduleName.kebab()} from './store';
export default {
  created() {
    const store = this.$store;
    const name = '${moduleName.kebab()}';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, ${moduleName.kebab()});
    }
  }
}
`;

const storeServicePath = `${path.join(storePath, 'index.js')}`;
const gettersPath = `${path.join(storePath, 'getters.js')}`;
const actionsPath = `${path.join(storePath, 'actions.js')}`;
const mutationsPath = `${path.join(storePath, 'mutations.js')}`;
const vueFilePath = `${path.join(modulePath, `${prefix}${moduleName.capitalize()}.vue`)}`;
const mixinPath = `${path.join(modulePath, 'localMixin.js')}`;

fs.mkdirSync(modulePath);
fs.mkdirSync(storePath);
fs.appendFileSync(storeServicePath, stateContent);
fs.appendFileSync(gettersPath, exportFileContent);
fs.appendFileSync(actionsPath, exportFileContent);
fs.appendFileSync(mutationsPath, exportFileContent);
fs.appendFileSync(vueFilePath, vueFileContent);
fs.appendFileSync(mixinPath, mixinContent);

success('Module', moduleName, 'generated!');
