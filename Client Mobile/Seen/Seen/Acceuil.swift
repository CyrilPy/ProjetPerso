//
//  Acceuil.swift
//  Seen
//
//  Created by Cyril Py on 05/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Acceuil: UIViewController, UITableViewDelegate, UITableViewDataSource {
    var items: [String] = ["Rechercher", "Mes films", "Mes séries", "Mon compte"]
    @IBOutlet var tableView: UITableView!

    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        self.tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        
        return self.items.count;
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        
        var cell:UITableViewCell = self.tableView.dequeueReusableCellWithIdentifier("cell") as UITableViewCell
        cell.textLabel?.text = self.items[indexPath.row]
        
        return cell
    }
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        
        switch indexPath.row {
        case 0 :
            dispatch_async(dispatch_get_main_queue(), {
                let storyboard = UIStoryboard(name: "Main", bundle: nil)
                let vc = storyboard.instantiateViewControllerWithIdentifier("Recherche") as Recherche
                self.presentViewController(vc, animated: true, completion: nil)
            });
        break;
        case 1 :
            dispatch_async(dispatch_get_main_queue(), {
                let storyboard = UIStoryboard(name: "Main", bundle: nil)
                let vc = storyboard.instantiateViewControllerWithIdentifier("Films") as Films
                self.presentViewController(vc, animated: true, completion: nil)
            });
            break;
        case 2 :
            dispatch_async(dispatch_get_main_queue(), {
                let storyboard = UIStoryboard(name: "Main", bundle: nil)
                let vc = storyboard.instantiateViewControllerWithIdentifier("Series") as Series
                self.presentViewController(vc, animated: true, completion: nil)
            });
            break;
        case 3 :
            dispatch_async(dispatch_get_main_queue(), {
                let storyboard = UIStoryboard(name: "Main", bundle: nil)
                let vc = storyboard.instantiateViewControllerWithIdentifier("Compte") as Compte
                self.presentViewController(vc, animated: true, completion: nil)
            });
            break;
        default:
        break;
        }
    }
}
