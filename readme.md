# Open Test PlateForm

* #### Specialite :
    * ##### api/Administration/pages/specialite/index : GET
        > return All specialite From DB As Json Array
    * ##### api/Administration/pages/specialite/new : POST
        > Post Form data as Request and save it to DB
         * Field :
               - abbreviation  ------> (varchar 255)
               - intitule      ------> (varchar 255)         
    * ##### api/Administration/pages/specialite/show/{id} : GET
        > return First specialite with selected id
    * ##### api/Administration/pages/specialite/edite/{id} : POST
        > Update specialite Using it's id 
          * Field :
               - abbreviation
               - intitule
               
    * ##### api/Administration/pages/specialite/delete/{id}
        > Delete specialite Using it's id 
    * ##### api/Administration/pages/specialite/restore/{id}
        > Restore specialite Using it's id 

* #### Exams :
    * ##### api/Administration/pages/exam/index : GET
    
    * ##### api/Administration/pages/exam/new : POST
        * Field :
              - date          ------> (DateTime)
              - description   ------> (varchar 255)
              - type          ------> (Enum : Blanche/officiel)
              - Pile          ------> (INT Foreign Key From Piles)
              - etudiant      ------> (INT Foreign Key From Etudiant)
              
    * ##### api/Administration/pages/exam/show/{id}
    * ##### api/Administration/pages/exam/edite/{id}
        * Field :
              - date
              - description
              - type
              - Pile
              - etudiant
              
    * ##### api/Administration/pages/exam/delete/{id}
    * ##### api/Administration/pages/exam/restore/{id}

* #### Module :
    * ##### api/Administration/pages/module/index : GET
    * ##### api/Administration/pages/module/new : POST
        * Field :
              - nom ------> (varchar 255)
              - MH ------> (INT)
              - specialite ------> (INT Foreign Key From Specialite)
    * ##### api/Administration/pages/module/show/{id}
    * ##### api/Administration/pages/module/edite/{id}
        * Field :
              - nom 
              - MH
              - specialite 
    * ##### api/Administration/pages/module/delete/{id}
    * ##### api/Administration/pages/module/restore/{id}
    
* #### Passage :
    * ##### api/Administration/pages/passage/index : GET
    * ##### api/Administration/pages/passage/new : POST
        * Field :
              - exam_ID
              - Question
              - Rep
    * ##### api/Administration/pages/passage/show/{id}
    * ##### api/Administration/pages/passage/edite/{id}
        * Field :
              - exam_ID
              - Question
              - Rep  
    * ##### api/Administration/pages/passage/delete/{id}
    * ##### api/Administration/pages/passage/restore/{id}
    
    
* #### Pile :
    * ##### api/Administration/pages/pile/index : GET
    * ##### api/Administration/pages/pile/new : POST
        * Field :
              - Description
              - duree
              - Max_Score
              - valide_Score
              - module_ID
              - prof
    * ##### api/Administration/pages/pile/show/{id}
    * ##### api/Administration/pages/pile/edite/{id}
        * Field :
              - Description
              - duree
              - Max_Score
              - valide_Score
              - module_ID
              - prof
    * ##### api/Administration/pages/pile/delete/{id}
    * ##### api/Administration/pages/pile/restore/{id}    
    
    
* #### Question :
    * ##### api/Administration/pages/question/index : GET
    * ##### api/Administration/pages/question/new : POST
        * Field :
              - Question
              - Type
              - Score
              - Pile_ID
    * ##### api/Administration/pages/question/show/{id}
    * ##### api/Administration/pages/question/edite/{id}
        * Field :
              - Question
              - Type
              - Score
              - Pile_ID
    * ##### api/Administration/pages/question/delete/{id}
    * ##### api/Administration/pages/question/restore/{id}    
    
    
* #### Reponse :
    * ##### api/Administration/pages/reponse/index : GET
    * ##### api/Administration/pages/reponse/new : POST
        * Field :
              - reponse
              - is_true
              - Question_id
    * ##### api/Administration/pages/reponse/show/{id}
    * ##### api/Administration/pages/reponse/edite/{id}
        * Field :
              - reponse
              - is_true
              - Question_id
    * ##### api/Administration/pages/reponse/delete/{id}
    * ##### api/Administration/pages/reponse/restore/{id}    
    
    
    
* #### -- :
    * ##### api/Administration/pages/--/index : GET
    * ##### api/Administration/pages/--/new : POST
        * Field :
              - 
              -  
    * ##### api/Administration/pages/--/show/{id}
    * ##### api/Administration/pages/--/edite/{id}
        * Field :
              - 
              -  
    * ##### api/Administration/pages/--/delete/{id}
    * ##### api/Administration/pages/--/restore/{id}   
    
    
Specialite :
    Administration/pages/specialite/index?token=
Exame :
    Administration/pages/exam/index?token=
Module
    Administration/pages/module/index?token=
Passage
    Administration/pages/passage/index?token=
Piles :
    Administration/pages/pile/index?token=
Question :
    Administration/pages/question/index?token=
Reponse :
   Administration/pages/reponse/index?token=
    

    
    
    
    