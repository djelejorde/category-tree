import { NestedTreeControl } from '@angular/cdk/tree';
import { Component, OnInit, QueryList, ViewChildren } from '@angular/core';
import { MatCheckbox } from '@angular/material/checkbox';
import { MatTreeNestedDataSource } from '@angular/material/tree';
import { CategoryService } from 'src/app/core/http/categories/category.service';
import { AuthService } from 'src/app/core/services/auth.service';
import { Token } from 'src/app/core/services/token';
import { Category } from '../../category';

@Component({
  selector: 'categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss'],
  providers: [AuthService, CategoryService]
})
export class CategoriesComponent implements OnInit {
  @ViewChildren('treeCheckboxes') treeCheckboxes: QueryList<MatCheckbox>
  treeControl = new NestedTreeControl<Category>(category => category.children);
  dataSource = new MatTreeNestedDataSource<Category>();
  selectedCategories: Category[] = []
  token: Token
  

  constructor(
    private categoryService: CategoryService,
    private authService: AuthService,
  ) {}

  hasChild = (_: number, category: Category) => !!category.children && category.children.length > 0;

  
  ngOnInit(): void {
    this.requestToken()
    this.getCategories()
  }

  requestToken() {
    this.authService
      .requestToken()
      .subscribe(token => {
        this.token = token
        this.authService.setToken(token.token)
      })
  }

  getCategories() {
    this.categoryService
      .getCategories()
      .subscribe(categories => {
        this.dataSource.data = this.arrangeCategories(categories)
      })
  }

  arrangeCategories(categories: Category[]) {
    let groupedCategories = []
    
    groupedCategories = categories.map(category => {

      category.children = categories.filter(sub => sub.parent_id === category.id)
      
      // this.categoryStore.setCategory(
      //   category.id,
      //   category.label,
      //   category.parent_id,
      //   category.children
      // )

      return category
    }).filter(category => category.parent_id == 0)
    
    return groupedCategories
  }

  selectAllChildren(category: Category) {
    this.selectedCategories.push(category)
    this.tickCheckbox(category.id)
    this.treeControl.expandDescendants(category)
    this.treeControl.getDescendants(category).map(cat => {
      if (this.selectedCategories.indexOf(cat) === -1) {
        this.selectedCategories.push(cat)
      }

      this.tickCheckbox(cat.id)
    })
  }

  addToSelected(category: Category): void {
    const index = this.selectedCategories.indexOf(category);

    if (index >= 0) {
      this.selectedCategories.splice(index, 1);
      this.treeControl.collapse(category)
      this.unTickChildrenCheckboxes(category)
    } else {
      this.selectedCategories.push(category)
    }
  }

  removeSelected(category: Category): void {
    const index = this.selectedCategories.indexOf(category)

    this.unTickCheckbox(category.id)

    if (index >= 0) {
      this.unTickChildrenCheckboxes(category)
      this.treeControl.collapse(category)
      this.selectedCategories.splice(index, 1);
    }
  }

  clearSelected(e: any) {
    this.treeControl.collapseAll()
    this.selectedCategories = []
    this.treeCheckboxes.map(cb => cb.checked = false)

    e.stopPropagation()

    return false
  }

  unTickCheckbox(name: any) {
    const currentSelectedCheckbox = this.treeCheckboxes.filter(
      cb => cb.name !== null && cb.name === name
    )

    if (currentSelectedCheckbox.length) {
      currentSelectedCheckbox[0].checked = false
    }
  }

  unTickChildrenCheckboxes(category: Category) {
    const children = this.treeControl.getDescendants(category)

    if (children.length > 0) {
      
      children.map(child => {
        const toUncheck = this.treeCheckboxes.find(cb => {
          return Number(cb.name || '') === Number(child.id)
        })

        if (toUncheck) toUncheck.checked = false

        return child
      })

      this.selectedCategories = this.selectedCategories.filter(sel => !children.includes(sel))
    }
  }

  tickCheckbox(name: any)
  {
    this.treeCheckboxes.map(cb => {
      if (name === cb.name) {
        cb.checked = true
      }

      return cb
    })
  }
}
