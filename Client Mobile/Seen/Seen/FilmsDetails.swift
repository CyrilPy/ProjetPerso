//
//  FilmsDetails.swift
//  Seen
//
//  Created by Cyril Py on 07/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class FilmsDetails: UIViewController {
    var pagePrecedente : String!
    
    var id_bs : String!
    var titre : String!
    var titre_original : String!
    var date : String!
    var duree : String!
    var langue : String!
    var realisateur : String!
    var synopsis : String!
    
    @IBOutlet weak var lTitre: UILabel!
    @IBOutlet weak var lDate: UILabel!
    @IBOutlet weak var lDuree: UILabel!
    @IBOutlet weak var lLangue: UILabel!
    @IBOutlet weak var lRealisateur: UILabel!
    @IBOutlet weak var tvSynopsis: UITextView!
    
    @IBOutlet weak var btnAjouter: UIBarButtonItem!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        lTitre.text = titre
        lDate.text = date
        lDuree.text = duree
        lLangue.text = langue
        lRealisateur.text = realisateur
        tvSynopsis.text = synopsis
    
        if (self.pagePrecedente == "films"){
            btnAjouter.enabled = false
        }else if(self.pagePrecedente == "recherche"){
            btnAjouter.enabled = true
        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func getJSON(urlToRequest: String) -> NSData{
        return NSData(contentsOfURL: NSURL(scheme: "http", host: "perso.imerir.com", path: urlToRequest)!)!
    }
    
    func parseJSON(inputData: NSData) -> NSDictionary{
        var error: NSError?
        var films: NSDictionary = NSJSONSerialization.JSONObjectWithData(inputData, options: NSJSONReadingOptions.MutableContainers, error: &error) as NSDictionary
        return films
    }
    
    @IBAction func Ajouter(sender: UIBarButtonItem) {
        
        synopsis = synopsis.stringByReplacingOccurrencesOfString("\"", withString: "\\\"", options: NSStringCompareOptions.LiteralSearch, range: nil)
        synopsis = synopsis.stringByReplacingOccurrencesOfString("&", withString: "and", options: NSStringCompareOptions.LiteralSearch, range: nil)
        titre = titre.stringByReplacingOccurrencesOfString("&", withString: "and", options: NSStringCompareOptions.LiteralSearch, range: nil)
        titre_original = titre_original.stringByReplacingOccurrencesOfString("&", withString: "and", options: NSStringCompareOptions.LiteralSearch, range: nil)
        realisateur = realisateur.stringByReplacingOccurrencesOfString("&", withString: "and", options: NSStringCompareOptions.LiteralSearch, range: nil)
        
        var json = parseJSON(getJSON("/cpy/Seen/insertion.php?quoi=f&id_bs=" + id_bs + "&titre_f=" + titre + "&titre_original=" + titre_original + "&synopsis=" + synopsis + "&realisateur=" + realisateur + "&date_sortie=" + date + "&duree=" + duree + "&langue=" + langue))
        
        let code = (json as NSDictionary)["code"] as String
        
        if (code == "1"){
            dispatch_async(dispatch_get_main_queue(), {
                var alert = UIAlertController(title: "Film ajouté", message: self.titre + " a bien été ajouté !", preferredStyle: UIAlertControllerStyle.Alert)
                alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.Default, handler: nil))
                self.presentViewController(alert, animated: true, completion: nil)
            });
            btnAjouter.enabled = false
        }else{
            println("Ajout echoué.");
            dispatch_async(dispatch_get_main_queue(), {
                var alert = UIAlertController(title: "Film déjà ajouté", message: self.titre + " fait déjà partie de vos films !", preferredStyle: UIAlertControllerStyle.Alert)
                alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.Default, handler: nil))
                self.presentViewController(alert, animated: true, completion: nil)
            });
            btnAjouter.enabled = false
        }
    }
    
    @IBAction func Retour(sender: AnyObject) {
        dispatch_async(dispatch_get_main_queue(), {
            if (self.pagePrecedente == "films"){
                let storyboard = UIStoryboard(name: "Main", bundle: nil)
                let vc = storyboard.instantiateViewControllerWithIdentifier("Films") as Films
                self.presentViewController(vc, animated: true, completion: nil)
            }else if(self.pagePrecedente == "recherche"){
                let storyboard = UIStoryboard(name: "Main", bundle: nil)
                let vc = storyboard.instantiateViewControllerWithIdentifier("Recherche") as Recherche
                self.presentViewController(vc, animated: true, completion: nil)
            }
            
        });
    }
}
