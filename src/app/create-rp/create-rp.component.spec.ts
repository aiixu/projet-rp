import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateRPComponent } from './create-rp.component';

describe('CreateRPComponent', () => {
  let component: CreateRPComponent;
  let fixture: ComponentFixture<CreateRPComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CreateRPComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateRPComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
