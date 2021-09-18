<template>
    <div class="app-container">
        <div class="custom-tree-container">
            <div class="block">
                <el-tree
                :data="data"
                node-key="id"
                default-expand-all
                :expand-on-click-node="false"
                :props="defaultProps">
                <span class="custom-tree-node" slot-scope="{ node, data }">
                    <span>{{ node.label }}</span>
                    <span>
                    <el-button
                        type="text"
                        size="mini"
                        @click="() => edit(data)">
                        编辑
                    </el-button>
                    <el-button
                        type="text"
                        size="mini"
                        @click="() => remove(node, data)">
                        删除
                    </el-button>
                    </span>
                </span>
                </el-tree>
            </div>
        </div>
        <!-- Form -->
        <el-dialog :title="dialogTitle" :visible.sync="dialogFormVisible">
          <el-form :label-position="labelPosition" :model="form">
            <el-form-item label="菜单名称" :label-width="formLabelWidth">
              <el-input v-model="form.name" autocomplete="off" readonly="readonly" disabled></el-input>
            </el-form-item>
            <el-form-item label="路径" :label-width="formLabelWidth">
              <el-input v-model="form.path" autocomplete="off" readonly="readonly" disabled></el-input>
            </el-form-item>
            <el-form-item label="组件名称" :label-width="formLabelWidth">
              <el-input v-model="form.component" autocomplete="off" readonly="readonly" disabled></el-input>
            </el-form-item>
            <el-form-item label="重定向路径" :label-width="formLabelWidth">
              <el-input v-model="form.redirect" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="主题" :label-width="formLabelWidth">
              <el-input v-model="form.title" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="图标" :label-width="formLabelWidth">
              <el-input v-model="form.icon" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="高亮菜单" :label-width="formLabelWidth">
              <el-input v-model="form.activeMenu" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="" prop="type">
              <el-checkbox-group v-model="form.type">
                <el-checkbox label="隐藏" name="hidden"></el-checkbox>
                <el-checkbox label="总是显示" name="alwaysShow"></el-checkbox>
                <el-checkbox label="显示缓存" name="noCache"></el-checkbox>
                <el-checkbox label="标签页总显示" name="affix"></el-checkbox>
                <el-checkbox label="面包屑导航" name="breadCrumb"></el-checkbox>
              </el-checkbox-group>
            </el-form-item>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button type="danger" @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="() => doEdit()">提 交</el-button>
          </div>
        </el-dialog>
    </div>
</template>



<script>
  import { getMenus,updateMenus } from '@/api/menu'
  import { Message } from 'element-ui'
  let id = 1000;

  export default {
    inject: ["reload"],
    data() {
      return {
        data: [],
        labelPosition:'left',
        dialogTitle:'',
        dialogFormVisible: false,
        form: {
          id: '',
          name: '',
          path: '',
          component: '',
          redirect: '',
          title: '',
          icon: '',
          activeMenu: '',
          type: [],
          newType: {}
        },
        formLabelWidth: '120px',
        defaultProps: {
          children: 'children',
          label: 'title'
        }
      };
    },
    created() {
        this.getData()
    },
    methods: {
      async getData() {
          const res = await getMenus()
          this.data = res.data
      },
      edit(data) {
        this.dialogTitle = '编辑菜单 (' + data.title + ')'
        this.form.id = data.id
        this.form.name = data.name
        this.form.path = data.path
        this.form.component = data.component
        this.form.redirect = data.redirect
        this.form.title = data.title
        this.form.icon = data.icon
        this.form.activeMenu = data.activeMenu
        this.form.type = []
        this.form.newType = {}

        data.hidden == 1 && this.form.type.push('隐藏')
        data.alwaysShow == 1 && this.form.type.push('总是显示')
        data.noCache == 1 && this.form.type.push('显示缓存')
        data.affix == 1 && this.form.type.push('标签页总显示')
        data.breadCrumb == 1 && this.form.type.push('面包屑导航')

        this.dialogFormVisible = true
      },
      async doEdit() {
        let map = {
          "hidden": "隐藏",
          "alwaysShow": "总是显示",
          "noCache": "显示缓存",
          "affix": "标签页总显示",
          "breadCrumb": "面包屑导航"
        }
        
        for(let key in map){
          if(this.form.type.includes(map[key])){
            this.form.newType[key] = 1
          }else{
            this.form.newType[key] = 0
          }
        }
        
        console.log(this.form)
        const res = await updateMenus(this.form)
        if (res.code == 0) {
          this.$message({
            message: '更新成功',
            type: 'success',
            duration: 2000
          });
          this.dialogFormVisible = false;
          this.reload()
        }
      },
      remove(node, data) {
        const parent = node.parent;
        const children = parent.data.children || parent.data;
        const index = children.findIndex(d => d.id === data.id);
        children.splice(index, 1);
      },
    }
  };
</script>

<style>
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
  }
</style>