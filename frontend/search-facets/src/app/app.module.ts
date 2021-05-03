import { NgModule } from '@angular/core'
import { FormsModule } from '@angular/forms'
import { BrowserModule } from '@angular/platform-browser'
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http'
import { AppRoutingModule } from './app-routing.module'
import { BrowserAnimationsModule } from '@angular/platform-browser/animations'
import { MatTreeModule } from '@angular/material/tree'
import { MatIconModule } from '@angular/material/icon'
import { MatCheckboxModule } from '@angular/material/checkbox'
import { MatChipsModule } from '@angular/material/chips'
import { MatButtonModule } from '@angular/material/button'

import { AppComponent } from './app.component';

import { CategoryStoreService } from './core/services/category.store.service';
import { CategoriesComponent } from './modules/categories/components/categories/categories.component';
import { TokenInterceptor } from './core/interceptors/token.interceptor'
import { AuthService } from './core/services/auth.service'


@NgModule({
  declarations: [
    AppComponent,
    CategoriesComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatTreeModule,
    MatIconModule,
    MatCheckboxModule,
    MatChipsModule,
    MatButtonModule
  ],
  providers: [
    AuthService,
    CategoryStoreService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptor,
      multi: true
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
