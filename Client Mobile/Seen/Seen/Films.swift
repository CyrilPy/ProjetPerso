//
//  Films.swift
//  Seen
//
//  Created by Cyril Py on 06/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Films: UIViewController, UITableViewDelegate, UITableViewDataSource  {
    
    @IBOutlet weak var tableView: UITableView!
    var items: NSDictionary!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.items = parseJSON(getJSON("http://perso.imerir.com/cpy/Seen/listeVu.php?quoi=f&nb=100"))
        
        self.tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")
        self.tableView.rowHeight = 60.0
    }
    
    
    func getJSON(urlToRequest: String) -> NSData{
        return NSData(contentsOfURL: NSURL(string: urlToRequest)!)!
    }
    
    func parseJSON(inputData: NSData) -> NSDictionary{
        var error: NSError?
        var films: NSDictionary = NSJSONSerialization.JSONObjectWithData(inputData, options: NSJSONReadingOptions.MutableContainers, error: &error) as NSDictionary
        return films
    }
    
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return self.items["film"]!.count;
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        
        var cell = self.tableView.dequeueReusableCellWithIdentifier("cell") as? UITableViewCell
        
        cell = UITableViewCell(style: UITableViewCellStyle.Subtitle, reuseIdentifier: "cell")
        
        cell!.accessoryType = UITableViewCellAccessoryType(rawValue: 1)!
        
        if let navn = self.items["film"]![indexPath.row]["titre_f"] as? NSString {
            cell!.textLabel?.text = navn
        } else {
            cell!.textLabel?.text = "No Name"
        }
        
        if let realisateur = self.items["film"]![indexPath.row]["realisateur_f"] as? NSString {
            if let date_sortie = self.items["film"]![indexPath.row]["date_sortie_f"] as? NSString {
                cell!.detailTextLabel?.text = date_sortie + " - " + realisateur
            }
        }
        return cell!
    }
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {

        dispatch_async(dispatch_get_main_queue(), {
            let storyboard = UIStoryboard(name: "Main", bundle: nil)
            let vc = storyboard.instantiateViewControllerWithIdentifier("FilmsDetails") as FilmsDetails
            vc.pagePrecedente = "films"
            vc.titre = self.items["film"]![indexPath.row]["titre_f"] as String
            vc.date = self.items["film"]![indexPath.row]["date_sortie_f"] as String
            vc.duree = self.items["film"]![indexPath.row]["duree_f"] as String
            vc.langue = self.items["film"]![indexPath.row]["langue_f"] as String
            vc.realisateur = self.items["film"]![indexPath.row]["realisateur_f"] as String
            vc.synopsis = self.items["film"]![indexPath.row]["synopsis_f"] as String
            
            self.presentViewController(vc, animated: true, completion: nil)
        });
    }

        @IBAction func RetourAcceuil(sender: UIBarButtonItem) {
        dispatch_async(dispatch_get_main_queue(), {
            let storyboard = UIStoryboard(name: "Main", bundle: nil)
            let vc = storyboard.instantiateViewControllerWithIdentifier("Acceuil") as Acceuil
            self.presentViewController(vc, animated: true, completion: nil)
        });
    }
}

