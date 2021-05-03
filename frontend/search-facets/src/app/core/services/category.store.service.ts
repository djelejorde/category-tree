import { Injectable } from "@angular/core";
import { BehaviorSubject } from "rxjs";
import { Category } from "src/app/modules/categories/category";

@Injectable()
export class CategoryStoreService {
  private readonly _categories = new BehaviorSubject<Category[]>([]);

  readonly categories$ = this._categories.asObservable();

  private readonly _selectedCategory = new BehaviorSubject<Array<number>>([]);

  readonly selectedCategory$ = this._selectedCategory.asObservable();

  get categories(): Category[] {
    return this._categories.getValue();
  }

  set categories(val: Category[]) {
    this._categories.next(val);
  }

  get selectedCategory(): Array<number> {
    return this._selectedCategory.getValue();
  }

  set selectedCategory(val: Array<number>) {
    this._selectedCategory.next(val);
  }

  setCategory(id: number, label: string, parent_id: number, children: Category[]) {
    this.categories = [
      ...this.categories, 
      {id, label, parent_id, children}
    ]
  }

  getCategoryChildren(id: number) {
    return this.categories.find(category => category.id === id)?.children
  }

  setSelectedCategory(categoryId: number) {
    this.selectedCategory = [
      ...this.selectedCategory,
      categoryId
    ]
  }

  getSelectedCategory() {
    return this.selectedCategory
  }
}
