import { Component, OnInit } from '@angular/core';
import axios from 'axios';

@Component({
  selector: 'app-api',
  templateUrl: './api.component.html',
  styleUrls: ['./api.component.css']
})

export class ApiComponent implements OnInit {
  tabSpaces: number = 4;

  items: Array<any> = [
    {
      tab: 0,
      title: "Créer",
      description: "Requête permettant de créer un utilisateur dans la base de données",
      method: "POST",
      route: "/api/users",
      request: {
        username: {
          type: {
            test: {
              type: "string"
            }
          },
          description: "Nom d'utilisateur"
        },
        email: {
          type: "string",
          description: "Adresse mail"
        },
        password_hash: {
          type: "string",
          description: "Hash du mot de passe"
        },
        is_public: {
          type: "boolean",
          description: "Défini si le compte est public ou privé"
        },
        profilePicture: {
          type: "string",
          optional: true,
          description: "URL de la photo de profil"
        },
        first_name: {
          type: "string",
          optional: true,
          description: "Prénom"
        },
        last_name: {
          type: "string",
          optional: true,
          description: "Nom"
        },
      },
      response: {
        id: "number"
      }
    }
  ];

  constructor() { }

  ngOnInit(): void {
    
  }

  formatRaw(obj: NonNullable<any>, indentLevel: number = 1, isSubObject: boolean = false, isLastObject: boolean = true): string {
    // calculate space count for a single tab, and space count for a curly bracket too
    const tab: string = " ".repeat(this.tabSpaces * indentLevel);
    const cbTab: string = " ".repeat(this.tabSpaces * (indentLevel - 1));

    // if the passed object is a sub object, no need to indent the opening curly bracket
    let result: string = `${isSubObject ? "" : cbTab}{\n`;

    // get the last key of the passed object
    const lastKey = Object.keys(obj)[Object.keys(obj).length - 1];

    // iterate over each item of obj
    for(const key in obj)
    {
      // store value corresponding to key in object, and check if it's the last key
      const value = obj[key];
      const valueType = value.type;
      const isLastKey = key == lastKey;

      // add key to result with the right indentation
      result += `${tab}"${value.optional ? `[${key}]` : key}": `;

      // if the value is an object, format it too
      if (typeof valueType == "object" && valueType !== null)
      {
        // by adding a new indentation level, by saying that the object is a sub object
        // the function needs to know if the passed object is the last one too
        result += this.formatRaw(valueType, indentLevel + 1, true, isLastKey) + "\n";
      }
      else
      {
        // add value to the current line, and if it's not the last key, add a comma, otherwhise, nothing
        result += valueType + `${isLastKey ? "" : ","}\n`;
      }
    }

    // return the result with closing curly bracket, with a trailling comma if the current object isn't the last one in the parent object
    return result + `${cbTab}}${isLastObject ? "" : ","}`;
  }

  formatTable(obj: NonNullable<any>, path: string = ""): Array<any> {
    let result: Array<any> = [];

    for(const key in obj)
    {
      const value = obj[key];
      const valueType = value.type;

      if (typeof valueType == "object" && valueType !== null)
      {        
        result = result.concat(this.formatTable(value.type, key));
      }
      else
      {
        result.push({
          name: `${path !== "" ? `${path}.${key}` : key}`,
          type: valueType,
          optional: value.optional ? "Oui" : "Non",
          description: value.description
        });
      }
    }
    
    return result;
  }

  formatAxios(object: NonNullable<any>): string
  {
    return "a";
  }

  
}
