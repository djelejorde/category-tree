import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { Observable, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { Category } from 'src/app/modules/categories/category';

@Injectable()
export class CategoryService {

  private categoriesUrl = 'http://localhost:8080/api/categories';
  private categoryUrl = `http://localhost:8080/api/category`;

  constructor(private http: HttpClient) { }

  /** GET categories from the server */
  getCategories(): Observable<Category[]>  {
    return this.http.get<Category[]>(this.categoriesUrl)
      .pipe(
        map(
          response => response['data']
        ),
        catchError(this.handleError<Category[]>('getCategories', []))
      );
  }

  /** GET categories from the server */
  getRootCategories(): Observable<Category[]>  {
    return this.http.get<Category[]>(this.categoriesUrl + `?parent=0`)
      .pipe(
        map(
          response => response['data']
        ),
        catchError(this.handleError<Category[]>('getRootCategories', []))
      );
  }

  /** GET categories from the server */
  getChildCategories(parentId: number): Observable<Category[]>  {
    return this.http.get<Category[]>(this.categoryUrl + `/${parentId}/children`)
      .pipe(
        map(
          response => response['data']
        ),
        catchError(this.handleError<Category[]>('getChildCategories', []))
      );
  }

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      // this.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }
}