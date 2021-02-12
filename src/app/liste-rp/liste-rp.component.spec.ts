import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListeRpComponent } from './liste-rp.component';

describe('ListeRpComponent', () => {
  let component: ListeRpComponent;
  let fixture: ComponentFixture<ListeRpComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ListeRpComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ListeRpComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
