//
//  Recherche.swift
//  Seen
//
//  Created by Cyril Py on 06/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Recherche: UIViewController, UITableViewDelegate, UITableViewDataSource, UISearchBarDelegate  {
    @IBOutlet weak var tableView: UITableView!
    @IBOutlet weak var sbSearch: UISearchBar!

    var items: NSDictionary!
    var searchText:String!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.items = parseJSON(getJSON("/cpy/Seen/recherche.php?quoi=f&titre= "))
        self.tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")
        self.tableView.rowHeight = 60.0
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func searchBar(searchBar: UISearchBar, textDidChange searchText: String) {
        if ((searchText) == ""){
            self.searchText = " "
        }else{
            self.searchText = searchText
        }
        self.items = parseJSON(getJSON("/cpy/Seen/recherche.php?quoi=f&titre=" + self.searchText))
        
        dispatch_async(dispatch_get_main_queue(), { () -> Void in
            self.tableView.reloadData()
        })
    }
    
    func searchBarSearchButtonClicked( searchBar: UISearchBar!)
    {
        self.searchText = searchBar.text
        searchBar.resignFirstResponder()
        
        self.items = parseJSON(getJSON("/cpy/Seen/recherche.php?quoi=f&titre=" + self.searchText))
        
        dispatch_async(dispatch_get_main_queue(), { () -> Void in
            self.tableView.reloadData()
        })
    }
    
    
    
    func getJSON(urlToRequest: String) -> NSData{
        return NSData(contentsOfURL: NSURL(scheme: "http", host: "perso.imerir.com", path: urlToRequest)!)!
    }
    
    func parseJSON(inputData: NSData) -> NSDictionary{
        var error: NSError?
        var json: NSDictionary = NSJSONSerialization.JSONObjectWithData(inputData, options: NSJSONReadingOptions.MutableContainers, error: &error) as NSDictionary
        return json
    }
    
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if ((self.items) != nil)  {
            return self.items["film"]!.count;
        } else {
            return 0;
        }
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
            vc.pagePrecedente = "recherche"
            vc.id_bs = self.items["film"]![indexPath.row]["id_bs_f"] as String
            vc.titre = self.items["film"]![indexPath.row]["titre_f"] as String
            vc.titre_original = self.items["film"]![indexPath.row]["titre_original_f"] as String
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