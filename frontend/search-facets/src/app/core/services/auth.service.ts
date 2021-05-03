import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { Token } from './token'

@Injectable()
export class AuthService {
  private tokenUrl = `http://localhost:8080/api/token`

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.requestToken()
  }

  public getToken(): string {
    return localStorage.getItem('token') || '';
  }

  public setToken(token: string) {
    localStorage.setItem('token', token)
  }

  requestToken(): Observable<Token>  {
    const result = this.http
        .post(this.tokenUrl, '')
        .pipe(
            map(
                (response: any) => response['data']
            ),
            catchError(err => {
                return of(err)
            })
        );
    
    return result
  }
}